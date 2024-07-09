<?php

function deleteImageIfExists(string | null $image_url)
{
    if (!empty($image_url) && file_exists("../../uploads/users/" . $image_url)) {
        unlink("../../uploads/users/" . $image_url);
    }
}
