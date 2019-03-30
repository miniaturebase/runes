# utfh8

String character analysis library for PHP.

```php
$character = new Character('a');

dump($character->toJson());
```

Would output the following data about the input character (`a`, in this case).

```json
{
  "bidirectionalClass": "L",
  "blockCode": 1,
  "category": "Ll",
  "combiningClass": 0,
  "encoding": "UTF-8",
  "glyph": "a",
  "isMirrored": false,
  "name": "LATIN SMALL LETTER A",
  "script": "Latin",
  "version": "1.1.0.0",
  "codepoint": "\\u61",
  "binary": "1100001",
  "hex": "61",
  "decimal": 97
}
```
