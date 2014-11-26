<?php
/*
|--------------------------------------------------------------------------
| Editable subscriber
|--------------------------------------------------------------------------
|
| Check if the current record is editable
|
*/
use Mentordeveloper\Authentication\Events\EditableSubscriber;
Event::subscribe(new EditableSubscriber());
/*
|--------------------------------------------------------------------------
| Profile type permissions subscriber
|--------------------------------------------------------------------------
|
| Check if the current use can edit the Profile permission types
|
*/
use Mentordeveloper\Authentication\Classes\CustomProfile\Events\ProfilePermissionSubscriber;
Event::subscribe(new ProfilePermissionSubscriber());
