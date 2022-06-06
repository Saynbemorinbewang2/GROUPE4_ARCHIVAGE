<?php

class Form
{
    public $html;

    public function __construct($method = 'post', $action = '#', $enctype='')
    {
        $this->html = '<form method="'. $method . '" action="' . $action . '" enctype="'. $enctype .'"></form>';
    }
    // champ de type texte
    public function inputText($name, $placeholder, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="text" name="' . $name . '" placeholder="' . $placeholder . '"'. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ multiligne
    public function textarea($name, $placeholder, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><textarea name="' . $name . '" placeholder="' . $placeholder . '"'. $attributes .' ></textarea></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ mot de passe
    public function inputPassword($name="password", $placeholder="Mot de passe", $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="password" name="' . $name . '" placeholder="' . $placeholder . '"'. $attributes .' /></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ cache
    public function inputHidden($name, $value)
    {
        $content = '<input type="hidden" name="' . $name . '" value="'. $value . '" />';
        $this->addClose($content);
    }
    // bouton de validation
    public function inputRadio($name, array $values)
    {
        $br_label = false;
        foreach($values as $label => $value){
            $content = '<p><input type="radio" name="'. $name . '" value="'. $value .'" /></p>';
            $content = $this->addLabel($content, $label, $br_label);
            $this->addClose($content);
        }
    }
    // liste d'options'
    public function select($name, array $values, $label = '', $br_label = false, $attributes = '', $selected ='')
    {
        $content = '<p><select name= "' . $name .'" '. $attributes .'><option></option>';
        foreach($values as $key=>$value){
            if($selected === $key){
                $content .= '<option value="'.$key.'" selected>' . $value . '</option>';
                continue;
            }
            $content .= '<option value="'.$key.'">' . $value . '</option>';
        }
        $content .= '</select></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // liste d'options hierarchisee'
    public function selectOptgroup($name, array $values, $label = '', $br_label = false, $attributes = '', $selected ='')
    {
        $content = '<p><select name= "' . $name .'" '. $attributes .'>';
        foreach($values as $legend => $group){
            $legend = str_replace(' ', '-', $legend);
            $content .= '<optgroup label =' . $legend . '>';
            foreach($group as $key => $value){
                if($selected === $key){
                    $content .= '<option class="selected" value="'.$key.'" selected>' . $value . '</option>';
                    continue;
                }
                $content .= '<option value="'.$key.'">' . $value . '</option>';
            }
            $content .= '</optgroup>';
        }
        $content .= '</select></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // zone de saisie avec selection'
    public function inputDatalist($name, array $values, $placeholder = '', $label = '', $br_label = false, $attributes = '')
    {
        $content = '<p><input list="myList" name="' . $name . '" placeholder="' . $placeholder . '" '. $attributes .'/>';
        $content .= '<datalist id="myList">';
        foreach($values as $value){
            $content .= '<option>' . $value . '</option>';
        }
        $content .= '</datalist></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // cases a cocher
    public function checkbox($name, array $values, $attributes = '')
    {
        $br_label = false;
        foreach($values as $label => $value){
            $content = '<p><input type="checkbox" name="'. $name . '[]" value="'. $value .'" '. $attributes .'/></p>';
            $content = $this->addLabel($content, $label, $br_label);
            $this->addClose($content);
        }
    }
    // champ pour uploader un fichier
    public function inputFile($name, $placeholder, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="file" name="' . $name . '" placeholder="' . $placeholder . '" '. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ pour adresse email
    public function inputMail($name, $placeholder, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="email" name="' . $name . '" placeholder="' . $placeholder . '" '. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ pour la date
    public function inputDate($name, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="date" name="' . $name . '" '. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ pour l'heure
    public function inputTime($name,  $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="time" name="' . $name . '" '. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // champ pour la date et l'heure
    public function inputDateTime($name, $label = '', $br_label= false, $attributes = '')
    {
        $content = '<p><input type="datetime" name="' . $name . '" '. $attributes .'/></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }

    public function inputSearch($name, $placeholder, $button = '', $attributes = '')
    {
        $content = '<p class="search"><input type="search" name="' . $name . '" placeholder="' . $placeholder . '"'. $attributes .'/>';
        $content .= '<button type="submit" name="search" value="1" class="search-button">' . $button . '</button></p>';
        $content = $this->addLabel($content, '', false);
        $this->addClose($content);
    }

    // zone d'affichage des erreurs
    public function errorsBox(array $errors)
    {
        $content = '<div class="box-error">';
        foreach($errors as $error){
            $content .= '<p>' . $error . '</p>';
        }
        $content .= '</div>';
        $this->addClose($content);
    }

    // zone d'affichage de message de succes
    public function sucessBox(array $sucess)
    {
        $content = '<div class="box-sucess">';
        foreach($sucess as $value){
            $content .= '<p>' . $value . '</p>';
        }
        $content .= '</div>';
        $this->addClose($content);
    }




    // methode qui ferme la balise form
    public function addClose($content)
    {
        $this->html = str_replace('</form>', $content, $this->html);
        $this->html .= '</form>';
    }
    // methode qui cree un label
    public function label($name, $br= false)
    {
        $content = '<label> '. $name .' : </label>';
        $content = $br === false ? $content : $content.'<br>';
        return $content;
    }
    // methode qui insere le label dans un paragraphe contenant le champ
    public function addLabel($content, $label, $br_label)
    {
        if(empty($label))
            return $content;

        $label_content =  $this->label($label, $br_label);
        $content = str_replace('<p>', $label_content, $content);
        $content = '<p>' . $content;
        return $content;
    }

    // bouton de validation
    public function submitButton($name, $value = 1, $label = '', $br_label = false)
    {
        $content = '<p><button type="submit" name="'.$name.'" value="' . $value . '" class="btn-primary">'. $name . '</button></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }
    // bouton de restauration
    public function resetButton($name, $value = -1, $label = '', $br_label = false)
    {
        $content = '<p><button type="reset" name="'.$name.'" value="' . $value . '" class="btn-secondary"/>'. $name . '</button></p>';
        $content = $this->addLabel($content, $label, $br_label);
        $this->addClose($content);
    }


    public function getForm()
    {
        return $this->html;
    }

}

?>