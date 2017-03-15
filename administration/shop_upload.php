<?php
$file = $_FILES['file'];
$file['name']=time().'_'.$file['name'];
if(move_uploaded_file($file['tmp_name'],'../images/shop/products/'.$file['name'])){
}
echo '{"name":"'.$file['name'].'","type":"'.$file['type'].'","size":"'.$file['size'].'","msg":"uploaded file successfully"}';
?>