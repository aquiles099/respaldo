<?php
namespace App\Models;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Schema;

class Model extends BaseModel {

  /**
   *
   */
  public function toInnerJson() {
    return $this->toJson();
  }


  /**
    *
    */
   public function getLang(){
       $lang = null;
       switch(App::getLocale()){
           case 'es' : $lang = 'spanish';break;
           case 'en' : $lang = 'english';break;
           default   : $lang = 'spanish';break;
       }
       return $lang;
   }

   /**
    *
    * @param type $query
    * @return type
    */
   public function scopeLanguage($query) {
       $lang = $this->getLang();
       if(is_null($query->getQuery()->columns)) {
         $query->addSelect(Schema::getColumnListing($this->table));
       }
       $query->addSelect("{$this->table}.id");
       $query->addSelect("$this->table.$lang as name");
       return $query;
   }

  /**
   *
   */
  public function scopeById($query, $value) {
    if(is_integer($value)) {
      return $query->where('id', '=', $value);
    } else if(is_string($value) && is_numeric($value)) {
      return $query->where('id', '=', intval($value));
    }
    return $query;
  }
}
