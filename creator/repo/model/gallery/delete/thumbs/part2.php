<?php
       if(file_exists($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_thumb_NUMBER_OF_THUMB_'])) {
            unlink($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_thumb_NUMBER_OF_THUMB_']);
        }