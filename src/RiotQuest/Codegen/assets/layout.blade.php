---
title: {{ $page->name }}
extends: _layouts.documentation
section: content
---

# {{ $page->name }}

This page describes the methods for the {{ $page->name }} Collection.

[Collection Source Code](https://github.com/supergrecko/RiotQuest/blob/master/src/RiotQuest/Components/Collections/{{ $page->name }}.php)

@foreach($page->methods as $name => $state)
### Method <code>{{ $page->name }}::{{ $name }} => {{ $state->returns[0] }}</code>

```php
public function {{ $name }}( {{ count($state->params) > 0 ? implode(', ', $state->params->map(function ($el, $idx) { return "$el $idx"; })->toArray()) : 'void' }} ): {{ $state->returns[0] }}
```
    
@endforeach
