<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'columnName' => 'title',
   'fieldName' => 'title',
   'type' => 'text',
  ));
$metadata->mapField(array(
   'columnName' => 'description',
   'fieldName' => 'description',
   'type' => 'text',
  ));
$metadata->mapField(array(
   'columnName' => 'file',
   'fieldName' => 'file',
   'type' => 'text',
  ));
$metadata->mapField(array(
   'columnName' => 'user_id',
   'fieldName' => 'userId',
   'type' => 'integer',
  ));
$metadata->mapField(array(
   'columnName' => 'category_id',
   'fieldName' => 'categoryId',
   'type' => 'integer',
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);