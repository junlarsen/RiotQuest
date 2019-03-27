# {{ $class->short }}

Collection extension for [{{ $class->short }}]({{ $class->ref }}).

# Class Synopsis

```php
{{ $class->short }} extends Collection {

@foreach ($class->properties as $prop)
    {{ $prop->synopsis }}

@endforeach
@foreach ($class->methods as $method)
@if($method->defined->getShortName() == $method->parent->reflector->getShortName())
    {{ $method->synopsis }}

@endif
@endforeach
}
```

# Properties

| Property | Data Type | Description |
|----------|-----------|-------------|
@foreach ($class->properties as $prop)
| `{{ $prop->name }}` | `{{ $prop->type }}` | {{ $prop->desc }} |
@endforeach
# Methods

| Method | Parameters | Return Value | Description |
|--------|------------|--------------|-------------|
@foreach ($class->methods as $method)
@if($method->defined->getShortName() == $method->parent->reflector->getShortName())
| `{{ $method->name }}`  | `{{ $method->paramsText }}` | `{{ str_replace('|', ',', $method->type) }}` | {{ $method->desc }} |
@endif
@endforeach

> This document was generated using Reflection. If you see any errors, please let us know by opening an issue.
