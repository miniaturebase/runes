# utfh8

String character analysis library for PHP.

See [compart unicode documentation](https://www.compart.com/en/unicode/) for useful information about unicode characters that PHP does not handle yet.

```php
$character = new Character('a');

dump($character->toJson());
```

Would output the following data about the input character (`🍗`, in this case).

```json
{
  "bidirectionalClass": "ON",
  "binary": "11110000100111111000110110010111",
  "blockCode": 205,
  "bytes": 2,
  "category": "So",
  "codepoint": "U+1F357",
  "combiningClass": 0,
  "decimal": 4036988311,
  "encoding": "UTF-16",
  "glyph": "🍗",
  "hex": "f09f8d97",
  "isMirrored": false,
  "name": "POULTRY LEG",
  "script": "Common",
  "utf8": "0xF0 0x9F 0x8D 0x97",
  "utf16": "0xD83C 0xDF57",
  "utf32": "0x0001F357",
  "version": "6.0.0.0"
}

```
