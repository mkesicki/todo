<?php
    namespace App;
    use Illuminate\Database\Eloquent\Model;
    class Tasks extends Model
    {
       //
       protected $table = "tasks";
       protected $fillable = [
           "name",
           "description",
           "status",
           "list_id",
           "category_id",
           "date",
        ];
    }