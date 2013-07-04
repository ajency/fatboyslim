<?php
/* call to python script refer path to locate script*/
function fetchDomainUsers(){

 $pyscript = 'C:\pythonprograms\program.py';
            $python = 'C:\Python25\python.exe';
            $filePath = 'C:\pythonprograms\test.txt';

            $cmd = "$python $pyscript $filePath";

            return exec($cmd, $output);
           
 }

?>