<?php

function ColorForStatus($status){
    switch($status){
        case "1": return "bg-white text-dark";
        case "2": return "bg-success text-white";
        case "3": return "bg-danger text-white";
        case "4": return "bg-warning text-white";
    }
    return "bg-white text-dark";
}