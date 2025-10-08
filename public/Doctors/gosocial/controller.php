<?php
switch ($viewpage) {
    case 'details':
        $article_content = json_decode(base64_decode($keys),true);
        $doctor_code = $session->get('usercode');
        // var_dump($article_content);
        break;
    
    default:
        # code...
        break;
}
?>