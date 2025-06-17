<?php

class functionsClass {

    private $colors = [
        "primary",
        "secondary",
        "success",
        "danger",
        "warning",
        "info",
        "light",
        "dark"
    ];

    public function alert_label($msg = [],$color = "",$icon = "ri-error-warning-line"){
        if(!in_array($color,$this->colors)) $color = "primary";
        if($color == 'light') {
            $text_color = "text-body";
        }else{
            $text_color = "text-white";
        }
        $html = '<div class="alert alert-'.$color.' alert-dismissible bg-'.$color.' '.$text_color.' alert-label-icon fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <i class="'.$icon.' label-icon"></i>';
            foreach($msg as $m){
                $html .= $m.'<br/>';
            }
            $html .= '</div>';
        return $html;
    }

    public function alert_leftborder($msg = "",$color = "",$icon = "ri-error-warning-line"){
        if(!in_array($color,$this->colors)) $color = "primary";
        $html = '<div class="alert alert-'.$color.' alert-border-left alert-dismissible fade show" role="alert">
        <i class="'.$icon.' me-3 align-middle"></i>';
        $html .= $msg.'<br>';
        $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return $html;
    }

    public function alert_outline($msg = [],$color = ""){
        if(!in_array($color,$this->colors)) $color = "primary";

        $html = '<div class="alert alert-'.$color.' alert-dismissible border-2 bg-body-secondary fade show" role="alert"><ul class="list-unstyled">';
        foreach($msg as $m){
            $html .= '<li>'.$m.'</li>';
        }
        $html .= '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return $html;
    }

    public function alert_dissmiss($msg = [],$color = "", $border = true){
        if(!in_array($color,$this->colors)) $color = "primary";
        if($border == false) $border = "border-0";

        $html = '<div class="alert alert-'.$color.' '.$border.' alert-dismissible fade show" role="alert"><ul class="list-unstyled">';
        foreach($msg as $m){
            $html .= '<li>'.$m.'</li>';
        }
        $html .= '</ul><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        return $html;
    }

    public function alert_default($msg = [],$color = "", $border = true){
        if(!in_array($color,$this->colors)) $color = "primary";
        if($border == false) $border = "border-0";

        $html = '<div class="alert alert-'.$color.' '.$border.'" role="alert"><ul class="list-unstyled">';
        foreach($msg as $m){
            $html .= '<li>'.$m.'</li>';
        }
        $html .= '</ul></div>';
        return $html;
    }

    public function dmY($date = "") {
        if($date == "") $date = date("Y-m-d H:i:s");
        return date("d.m.Y",strtotime($date));
    }
}

$func = new functionsClass();

?>