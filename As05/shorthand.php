<?php
/*
<div class="form-group">
    <label for="usernameInput">Username</label>
    <input type="text" name="username" class="form-control" id="usernameInput" value="<?php echo !empty($username) ? $username : ''; ?>">
</div>

<div class="form-group">
    <label for="usernameInput">Username</label>
    <input type="text" name="username" class="form-control <?php echo !empty($usernameError) ? 'is-invalid' : ''; ?>"
        id="usernameInput" value="<?php echo !empty($username) ? $username : ''; ?>">
    <?php if (!empty($usernameError)) { ?>
        <span class="invalid-feedback"><?php echo $usernameError; ?></span>
    <?php } ?>
</div>

<div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
    <label class="control-label">Picture</label>
    <div class="controls">
        <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
        <input name="userfile" type="file" id="userfile">
    </div>
</div>
*/
?>
<?php



class Shorthand {

    private static $numObjects = 0;

    // Element IDs auto-increment using this method.
    private static function createUniqueID() {
        $id = 'element-' . self::$numObjects;
        self::$numObjects += 1;
        return $id;
    }

    /*
    variableName
    error
    */

    public static function echoImageFormGroup($variableName, $error) {
        $elementID = self::createUniqueID();
        $inputClass = $error == null ? 'form-group' : 'form-group is-invalid';
        echo "<div class='$inputClass'>";
        echo "<label for='$variableName'>Photo</label>";
        echo "<input type='file' name='$variableName' id='$variableName'>";
        if ($error != null) {
            echo "<span class='invalid-feedback'>$error</span>";
        }
        echo '</div>';
    }


    /*
    labelText
    variableName
    inputID // Auto-generated
    inputType // Implied by function name
    error
    defaultValue
    */

    public static function echoTextInputFormGroup($labelText, $variableName, $error, $defaultValue) {
        $elementID = self::createUniqueID();
        echo '<div class="form-group">';
        // Echos the label for the form group.
        echo "<label for='$elementID'>$labelText</label>";
        // Echos the input element.
        echo "<input type='text' name='$variableName' class='form-control ";
        // Includes the .is-invalid class if the error is present.
        echo $error != null ? "is-invalid' " : "' ";
        echo "id='$elementID'";
        // Includes a default value if one is provided.
        echo $defaultValue != null ? "value='$defaultValue' >" : "> ";
        // Echos the error text, if not empty.
        if ($error != null) {
            echo '<span class="invalid-feedback">' . $error . '</span>';
        }
        echo '</div>';
    }
}