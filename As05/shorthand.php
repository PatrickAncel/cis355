<?php

class Shorthand {

    private static $numObjects = 0;

    // Element IDs auto-increment using this method.
    private static function createUniqueID() {
        $id = 'element-' . self::$numObjects;
        self::$numObjects += 1;
        return $id;
    }

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