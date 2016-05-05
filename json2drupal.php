<?php

$cli_options = getopt("",array( "file:", "table::", "module::", "output::" ));

// check for json file
if( isset($cli_options['file']) && $cli_options['file']!="" ){
    $file = $cli_options['file'];
}
else{
    die("ERROR: Please define the json file using, --file JSON_FILE_NAME\n");
}

// check for table name
if( isset($cli_options['table']) && $cli_options['table']!="" ){
    $table = $cli_options['table'];
}
else{
    $table = "table_name";
}

// check for module name
if( isset($cli_options['module']) && $cli_options['module']!="" ){
    $module = $cli_options['module'];
}
else{
    $module = "module";
}

// check for output file name
if( isset($cli_options['output']) && $cli_options['output']!="" ){
    $output_file = $cli_options['output'];
}
else{

    if($module!="module"){
        $output_file = $cli_options['module'].".install";
    }else{
        $output_file = "your_module.install";
    }


}

$json_data = "";

$lines = split("\n", file_get_contents($file, "r"));
foreach ($lines as $line) {
    if ($line !== "") {
        $json_data .= "$line\n";
    }
}

$data_array = json_decode($json_data,true);

loop_data($data_array,0);

function loop_data($data,$level){

    global $output;
    $level++;

    $x = 0;

    foreach($data as $k=>$v) {

        if($x==0) {
            $output .= " array(";
        }

            $output .= "\n".get_indent($level)."'$k' =>";

        if(is_array($v)) {

            if(isAssoc($v)) {
                $output .= loop_data($v, $level);
            }else{
                $output .= loop_object($v, $level);
            }

        }
        else{

            if(is_bool($v)){
                $output .= " '".($v ? 'TRUE' : 'FALSE')."'";
            }
            else {
                $output .= " '$v'";
            }
        }

        if($x == (count($data) - 1) ) {
            $output .= ",\n".get_indent($level-1).")";
        }else{
            $output .= ",";
        }

        $x++;

    }

}

function loop_object($data,$level){

    global $output;
    $level++;

    $x = 0;

    foreach($data as $k=>$v) {

        if($x==0) {
            $output .= " array(";
        }

        if(is_array($v)) {
            $output .= loop_object($v,$level);
        }
        else{
            $output .= "'$v'";
        }

        if($x == (count($data) - 1) ) {
            $output .= ")";
        }else{
            $output .= ",";
        }

        $x++;

    }

}

function isAssoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function get_indent($level) {

    $indent_string = "";
    $level = $level + 2;

    for($i=0; $i<$level-1; $i++) {
        $indent_string .= "  ";
    }

    return $indent_string;

}

$file_body =  "<?php

/**
 * @file
 * Provides a hook functions for Peak Brochure Order.
 */

/**
 * Implements hook_schema().
 */
function ".$module."_schema() {

  \$schema['$table'] =$output;

  return \$schema;

}
";

$output_file_res = fopen( $output_file , "w") or die("Unable to open file!");

if( fwrite($output_file_res, $file_body) ) {
    echo "\n\033[32mSchema File Created Successful.\033[0m\n";
}
else {
    echo "\nThere was an error creating the file.\n";
}