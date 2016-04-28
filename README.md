# json-to-drupal-db
A Simple php command line script to create Database Schema file ( ex: module.install ) for Drupal using JSON.

Note: this has been just written in few hours to make it bit more easy to define database schemas for drupal. Just shared on git hub for anyone else to use. The code might not be up to the proper standards since i did not want to spend too much time on it. Feel free to contribute if interested.


## What is this?
It surely is not that hard to define table structures in the php file it self. but when it comes to multiple tables with more number of fields and definitions, it might be a waste of time to write the same words over and over ( ex: 'array' and '=>' signs ) all the time.

Instead, It will be very much easy to define a JSON file and convert it to the Drupal's Database Schema Format.

## Usage
You need to simply run the file using CLI with the required Parameters.


`php json2drupal.php --file table.json --table=your_table --module=module_name --output=output_file_name`


Parameter | Usage | Description
------------ | ------------- | -------------
--file | Required | json file with defined table structure for drupal. Ex: table.json
--table | Optional | if you want the table name to be filled in the code.
--module | Optional | if you want the module name to be filled in the code.
--output | Optional | to define the output file path/name to be generated.

## To Do

* Remove .php extension
* Ability to Define Mulitple tables -  Currently it only supports one table per execution. If you have multiple tables, you can define them in seperate JSON files and Generate the PHP file and later at them all together.
* Boolean Fix - Currently the TRUE and FALSE values are generated with quotes. Feel free to fix that and contribute.
* Parameter Validations - Not that important since this will be only used in a development enviroment. but if anyone cares, feel free to validate the parameters ( for ex: if json file provided exists ) 

## Contributors

If anyone is interested in spending some time to make this better, which can save more time when generating schemas for drupal, feel free to contribute to this.
