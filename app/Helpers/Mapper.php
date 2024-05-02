<?php


namespace App\Helpers;

use App\Dtos\Dto;


class Mapper
{
    const withPaginationKey = "withPagination";
    public static function snakeToCamel($key)
    {
        // replace underscores with spaces, uppercase first letter of all words,
        // join them, lowercase the very first letter of the name
        if (isset($key))
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }

    public static function modelsToDtoArray($models, $dtoClass)
    {
        $dtos = array();
        $paginate = null;
        $content = array();
        foreach ($models as $model) {
            $dto = new $dtoClass();
            $attributes = $model->attributesToArray();
            foreach ($attributes as $key => $value) {
                $set_method_name = "set" . self::snakeToCamel($key);
                if (method_exists($dtoClass, $set_method_name)) {
                    $dto->{$set_method_name} ($value);
                }
            }

            array_push($dtos, $dto);
        }

        if (request(Constants::PAGINATE)) {
            $models_encode = json_encode($models);
            $models_json = json_decode($models_encode);
            $paginate["perPage"] = isset($models_json->per_page)?$models_json->per_page:null;
            $paginate["from"] = isset($models_json->from)?$models_json->from:null;
            $paginate["to"] = isset($models_json->to)?$models_json->to:null;
            $paginate["currentPage"] = isset($models_json->current_page)?$models_json->current_page:null;
            $paginate["lastPage"] = isset($models_json->last_page)?$models_json->last_page:null;
            $paginate["firstPageUrl"] = isset($models_json->first_page_url)?$models_json->first_page_url:null;
            $paginate["nextPageUrl"] = isset($models_json->next_page_url)?$models_json->next_page_url:null;
            $paginate["total"] = isset($models_json->total)?$models_json->total:null;
        }
        $content['data'] = $dtos;
        request(Constants::PAGINATE)?($content['pagination'] = $paginate):null;

        return $content;
    }

    public static function modelToDto($model, $dtoClass)
    {

        $dto = new $dtoClass();
        $attributes = $model->attributesToArray();
        foreach ($attributes as $key => $value) {
            $set_method_name = "set" . self::snakeToCamel($key);
            if (method_exists($dtoClass, $set_method_name)) {
                $dto->{$set_method_name} ($value);
            }
        }

        $content['data'] = $dto;
        return $content;
    }

    public static function ArrayToDto(array $request, Dto $dto)
    {


        foreach ($request as $key_name => $value) {
            $method_name = "set" . ucfirst($key_name);
            if (method_exists($dto, $method_name)) {
                $dto->{$method_name}($value);
            }
        }
        return $dto;
    }

    public static function DtoToArray(Dto $dto)
    {


        $array = json_decode(json_encode($dto), true);
        return $array;
    }

    /**
     * @param $model
     * @return mixed
     * @description map between model attributes and model variables
     */
    public static function setModelProperties($model)
    {

        $attributes = $model->getAttributes();
        foreach (get_object_vars($model) as $key_name => $value) {
            $method_name = "set" . ucfirst($key_name);
            if (method_exists($model, $method_name)) {
                $model->{$method_name}($value);
            } else {
                if (isset($attributes[$key_name]))
                    $model->{$key_name} = $attributes[$key_name];
            }
        }
        return $model;
    }

    public static function camelToUnderscore($string, $us = "_")
    {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }
    public static function camelToUnderscoreArray($array, $us = "_")
    {
        $underscored = [];
        if (isset($array) && is_array($array))
        foreach ($array as $key =>$value){
            $underscored[strtolower(preg_replace(
                '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $key))]=$value;

        }
        return $underscored;

    }

    public static function camelToSnake($string, $us = "_")
    {
        return strtolower(preg_replace(
            '/(?<=\d)(?=[A-Za-z])|(?<=[A-Za-z])(?=\d)|(?<=[a-z])(?=[A-Z])/', $us, $string));
    }
}
