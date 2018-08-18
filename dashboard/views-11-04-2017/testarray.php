<?php 

$array = array('Mainarray'=>
                    array('first'=>                                 
                            array('a'=>1,'b'=>2,'c'=>3)
                          ,
                         'secondchild'=>
                            array('d'=>11,'e'=>22,'f'=>33)
                          ,
                         'third'=>
                            array('g'=>55,'h'=>66,'i'=>77)
                          )
                );







$newarray = array();
foreach($array as $key=>$value)
{
   
    
    foreach($value as $keya=>$valdata)
    {
    echo '<pre>';
    echo($valdata[$keya]);
    echo '</pre>';
    
    
    
    }
}

?>