<?php
class WP_Html_Helper {
    
    
    //TODO FINISH ATTR AND EXTRAHTML
    
    public function print_text_field($label = '', $name = '', $id = '', $placeHolder, $value = '', $attr = '', $extraHtml =[]) {
        
        echo $this->print_field('text', $name, $label, $id, $placeHolder, $attr, $extraHtml);
        
    }
    
    public function print_password_field($label = '', $name = '', $id = '', $placeHolder, $value = '', $attr = '', $extraHtml =[]) {
        
        echo $this->print_field('password', $name, $label, $id, $placeHolder, $attr, $extraHtml);
        
    }
    
    public function print_email_field($label = '', $name = '', $id = '', $placeHolder, $value = '', $attr = '', $extraHtml =[]) {
        
        echo $this->print_field('email', $name, $label, $id, $placeHolder, $attr, $extraHtml);
        
    }
    
    public function print_checkbox_group($label, $name, $id, $options, $selected) {
        
        $html = '<div class="form-group">';
        
        $html .= '<div class="radio">';
        $html .= ' <label for="'.$name.'"> ';
        
        $index = 0;
        
        foreach($options as $option) :
        
            $html .= ' <input type="checkbox" name="' . $option['name'] . '" id="' . $option['id'] . '_'.$index.'" value="' . $option['value'] . '"';
            
            if ($selected === $option['value']) :
                $html .= ' checked';
            endif;
            
            $html .= '>' . $option['title'] . '</label>';
            
            $index++;
            
        endforeach;
        
        $html .= '</div>';
        $html .= '</div>';
        
        echo $html;
        
    }
    
    public function print_radio_group($label, $name, $id, $options, $selected) {
        
        $html = '<div class="form-group">';
        
        $html .= '<div class="radio">';
        $html .= ' <label>';
        
        $index = 0;
        
        foreach($options as $option) :
        
            $html .= ' <input type="radio" name="' . $option['name'] . '" id="' . $option['id'] . '_'.$index.'" value="' . $option['value'] . '"';
                 
                if ($selected === $option['value']) :
                    $html .= ' selected';
                endif;
                
            $html .= '>' . $option['title'] . '</label>';
            
        endforeach;
        
        $html .= '</div>';
        $html .= '</div>';
        
        echo $html;
        
    }
    
    public function print_dropdown($label, $name, $id, $options, $selected = '') {
        
        $html = '<div class="form-group">';
        $html .= '    <label for="'.$name.'">'.$label.'</label>';
        $html .= '<select id="'.$id.'" name="'.$name.'" class="form-group">';
        
        foreach($options as $key=>$value) :
        
            $html .= '<option value="'.$value.'"';
        
            if ($selected === $value):
                $html .= " selected";
            endif;
            $html .= '> ' . $key.'</option>';
        
        endforeach;
        $html .= '</select>';
        $html .= '</div>';
        
        echo $html;
        
    }
    
    private function print_field($type, $label, $name, $id, $placeHolder, $value, $attr, $extraHtml =[]) {
        
        $html = '<div class="form-group">';
        $html .= '    <label for="'.$name.'">'.$label.'</label>';
        $html .= '    <input type="'.$type.'" class="form-control" id="'.$id.'" value="'.$value.'" placeholder="'.$placeHolder.'">';
        $html .='</div>';
        
        return $html;
        
    }
    
    
}