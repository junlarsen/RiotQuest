---
title:  <?php echo e($page->name); ?>

extends: _layouts.documentation
section: content
---

# <?php echo e($page->name); ?>


This page describes the methods for the <?php echo e($page->name); ?> Collection.

[Collection Source Code](https://github.com/supergrecko/RiotQuest/blob/master/src/RiotQuest/Components/Collections/<?php echo e($page->name); ?>.php)

<?php $__currentLoopData = $page->methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
### Method <code><?php echo e($page->name); ?>::<?php echo e($name); ?> => <?php echo e($state->returns[0]); ?></code>

```php
public function <?php echo e($name); ?>( <?php echo e(count($state->params) > 0 ? implode(', ', $state->params->map(function ($el, $idx) { return "$el $idx"; })->toArray()) : 'void'); ?> ): <?php echo e($state->returns[0]); ?>

```
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\Projects\PHP\LeagueQuest\src\RiotQuest\Codegen\assets/layout.blade.php ENDPATH**/ ?>
