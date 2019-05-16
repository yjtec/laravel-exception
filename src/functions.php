<?php 
function tne($code,$extra=[]){
    throw new \Yjtec\Exception\ApiException($code,$extra);
}