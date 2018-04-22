    <?php
    include 'aesencryp.php';
    $inputText = "My text to encrypt";
    $inputKey = "My text to encrypt";
    $blockSize = 256;
    $aes = new AES($inputText, $inputKey, $blockSize);
    $enc = $aes->encrypt();
    $aes->setData($enc);
    $dec=$aes->decrypt();
    echo "After encryption: ".$enc."<br/>";
    echo "After decryption: ".$dec."<br/>";
    ?>