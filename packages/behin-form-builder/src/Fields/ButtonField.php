<?php

namespace MyFormBuilder\Fields;

class ButtonField extends AbstractField
{
    public function render(): string
    {
        $id = $this->attributes['id'];
        $style = $this->attributes['style'] ?? '';

        $s = "<button id='$id' style='$style'>";
        $s .= trans('fields.' . $this->name);
        $s .= '</button>';
        if(isset($this->attributes['script'])){
            $s .= '<script>';
            $s .= $this->attributes['script'];
            $s .= '</script>';
        }
        return $s;
    }
}
