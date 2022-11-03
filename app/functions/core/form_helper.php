<?php 
    function FormOpen($attributes = array() , $saveData = false)
    {
        
        if($saveData)
            FormSave();

        if(!isset($attributes['method']))
            $attributes['method'] = 'post';

        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        print <<<EOF
            <form $attributes>
        EOF;
    }

    function FormOpenMeta($attributes = array())
    {
        $attr = array_merge($attributes , [
            'enctype' => 'multipart/form-data'
        ]);

        FormOpen($attr);
    }

    function FormClose()
    {
        print <<<EOF
            </form>
        EOF;
    }


    
    function FormSave()
    {

        global $formSavedDatas;

        if(isset($_GET)){
            $formSavedDatas = $_GET;
        }
            
        if(isset($_POST)){
            $formSavedDatas = $_POST;
        }
    }

    function FormData($name = null)
    {
        global $formSavedDatas;
        
        if(is_null($name))
            return $formSavedDatas;
        return $formSavedDatas[$name] ?? null;
    }

    function FormLabel($html , $for = null, $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $html = ucwords($html);

        print <<<EOF
            <label {$attributes} for="{$for}">
                {$html}
            </label>
        EOF;
    }

    function FormCheckBox($name , $value = null, $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        print <<<EOF
            <input type="checkbox" name="{$name}" value="{$value}" {$attributes} />
        EOF;
    }

    function FormSmall($html , $attributes = NULL)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);


        $html = ucwords($html);

        print <<<EOF
            <small {$attributes}>
                {$html}
            </small>
        EOF;
    }

    function FormHidden($name , $value , $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        print <<<EOF
            <input type="hidden" name="{$name}"
                value="$value" $attributes>
        EOF;
    }

    function FormText($name , $value = null , $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <input type="text" name="{$name}"
                value="$value" $attributes>
        EOF;
    }

    function FormEmail($name , $value = null , $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <input type="email" name="{$name}"
                value="$value" $attributes>
        EOF;
    }

    function FormPassword($name , $value = null , $attributes = null , $preservePassword = false)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        if(!$preservePassword)
            $value = '';
        
        print <<<EOF
            <input type="password" name="{$name}"
                value="$value" $attributes>
        EOF;
    }
    
    function FormNumber($name , $value = null , $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <input type="number" name="{$name}"
                value="$value" $attributes>
        EOF;
    }

    function FormDate($name , $value = null, $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <input type="date" name="{$name}"
                value="$value" $attributes>
        EOF;
    }
    
    function FormTime($name , $value = null, $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <input type="time" name="{$name}"
                value="$value" $attributes>
        EOF;
    }
        
    function FormTextarea($name , $value = null , $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $value = is_null(FormData($name)) ? $value : FormData($name);

        print <<<EOF
            <textarea name="{$name}" $attributes>$value</textarea>
        EOF;
    }
    
    function FormFile($name, $attributes = null)
    {
        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        print <<<EOF
            <input type="file" name="{$name}" $attributes>
        EOF;
    }

    function FormSubmit($name , $value = null , $attributes = null)
    {
        if(is_null($attributes)){
            $attributes = [];
            $attributes['class'] = 'btn btn-primary';
        }else{

            if( !isset($attributes['class']) ) 
                $attributes['class'] = 'btn btn-primary';
        }

        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);
        $value = is_null($value) ? "Submit" : $value;
        
        print <<<EOF
            <input type="submit" name="{$name}"
                value="$value" $attributes>
        EOF;
    }

    function FormSelect($name , $values , $selected = null, $attributes = null)
    {
        $isAssoc = is_assoc($values);

        $attributes = is_null($attributes) ? $attributes : keypair_to_str($attributes);

        $options = '';

        $selected = is_null(FormData($name)) ? $selected : FormData($name);

        foreach($values as $key => $value)
        {
            $select = '';

            if($isAssoc)
            {
                if(! is_null($selected)) {
                    if(strtolower($key) == strtolower($selected)){
                        $select = 'selected';
                    }
                }

                if(!empty($value)){
                    $options .= "<option value='{$key}' {$select}> {$value} </option>";
                }
                
            }else{
                if(! is_null($selected)) {

                    if(strtolower($value) == strtolower($selected)){
                        $select = 'selected';
                    }
                }

                if(!empty($value)){
                    $options .= "<option value='{$value}' {$select}> {$value}</option>";
                }
                
            }
        }

        print <<<EOF
            <select name = "{$name}" {$attributes}>
                <option value=''>--Select</option>
                {$options}
            </select>
        EOF;
    }


    function do_action($functionName , $trigger = 'submit')
    {
        if(isset($_POST[$trigger]))
        {
            if( function_exists($functionName)){
                return call_user_func($functionName);
            }
            return false;
        }else{
            return false;
        }
    }

    function _post($name)
    {
        return trim(strEscape($_POST[$name]));
    }