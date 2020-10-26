# Graphql Exceptions

Better client save exceptions for the lighthouse-php graphql implementation.

## Installation

```
composer require tjventurini/graphql-exceptions
```

## Usage

### Intenral Error

Extend the `ClientSaveInternalGraphQLException` or throw it directly.

```php
try {
    throw new Exception('omg! what happened?!');
} catch (Exception $Exception) {
    ClientSaveInternalGraphQLException($Exception);
}
```

This will result in the following output.

```json
{
  "errors": [
    {
      "message": "There was an internal error!",
      "extensions": {
        "reason": "omg! what happened?!",
        "category": "internal"
      },
      "locations": [
        {
          "line": 2,
          "column": 3
        }
      ],
      "path": [
        "someQuery"
      ]
    }
  ],
  "data": {
    "someQuery": null
  }
}
```

### Validation Exception

Extend the `ClientSaveValidationGraphQLException` or throw it directly.

```php
try {
    $data = ['foo' => 'bar'];

    $Validator = Validator::make($data, [
        'foo' => 'required|in:baz'
    ]);

    if ($Validator->fails()) {
        throw new ValidationValidationException($Validator);
    }
} catch (ValidationValidationException $Exception) {
    throw new ClientSaveValidationGraphQLException($Exception);
} catch (\Exception $Exception) {
    throw new ClientSaveInternalGraphQLException($Exception);
}
```

This will result in the following output.

```json
{
  "errors": [
    {
      "message": "There was a validation error!",
      "extensions": {
        "reason": "The given data was invalid.",
        "errors": {
          "foo": [
            "The selected foo is invalid."
          ]
        },
        "category": "validation"
      },
      "locations": [
        {
          "line": 2,
          "column": 3
        }
      ],
      "path": [
        "someMutation"
      ]
    }
  ],
  "data": {
    "someMutation": null
  }
}
```