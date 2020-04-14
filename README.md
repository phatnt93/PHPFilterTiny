# PHPFilterTiny

## Filters
| Filter | Description |
| --- | --- |
| string | Sanitize the string by removing any script tags |
| urlencode | Sanitize the string by urlencoding characters |
| htmlencode | Sanitize the string by converting HTML characters to their HTML entities |
| email | Sanitize the string by removing illegal characters from emails |
| numbers | Sanitize the string by removing illegal characters from numbers |
| floats | Sanitize the string by removing illegal characters from float numbers |
| lower_case | Converts to lowercase |
| upper_case | Converts to uppercase |
| slug | Converts value to url-web-slugs. Include "Vietnamese" |
| trim | Remove spaces from the beginning and end of strings (PHP) |

## Example

```
<?php 

require "PHPFilterTiny.php";

use PHPFilterTiny\PHPFilterTiny;

$params = [
    'name' => '<a>PHP Filter Tiny </a>',
    'age' => '27abc(&*%',
    'slug' => 'PHP Filter Tiny '
];

$filter = [
    'name' => 'string',
    'age' => 'numbers',
    'slug' => 'string|trim|slug'
];

$tiny = new PHPFilterTiny();
$data = $tiny->run($params, $filter);

if ($tiny->error) {
    echo $tiny->msg;
}else{
    echo "<pre>";
    var_dump($data);
}
```
