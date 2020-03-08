<?php
    namespace App;
    use Illuminate\Database\Eloquent\Model;
    class Lists extends Model
    {
       //
       protected $table = "lists";
       protected $fillable = [
           "name",
           "description",          
           "date",
           "user_id"
        ];

    public function tasks()
    {
        return $this->hasMany('App\Tasks','list_id');
    }
}