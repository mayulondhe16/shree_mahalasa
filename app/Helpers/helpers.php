<?php
function uploadImage($request, $image_name, $path, $name) {

    if (!file_exists(storage_path().$path)) {
        File::makeDirectory(storage_path().'/'.$path,0777,true);
    }
    if($request->$image_name !== null) {
        $base64_encoded = base64_encode(file_get_contents($request->$image_name)); 
        $base64_decoded_content = base64_decode($base64_encoded);
        $path2 = storage_path().$path.$name;
        file_put_contents($path2, $base64_decoded_content);
    }
}

function uploadMultiImage($request, $image_name, $path, $name) {

    if (!file_exists(storage_path().$path)) {
        File::makeDirectory(storage_path().'/'.$path,0777,true);
    }
    if($request !== null) {
        $base64_encoded = base64_encode(file_get_contents($request)); 
        $base64_decoded_content = base64_decode($base64_encoded);
        $path2 = storage_path().$path.$name;
        file_put_contents($path2, $base64_decoded_content);
    }
}
?>