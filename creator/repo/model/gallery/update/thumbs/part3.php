<?php
                     if (!empty($result[0]['_CREATED_TABLE_PREFIX__img_url_thumb_NUMBER_OF_THUMB_'])) {
                    	copy($_SERVER['DOCUMENT_ROOT'].$result[0]['_CREATED_TABLE_PREFIX__img_url_thumb_NUMBER_OF_THUMB_'], $_SERVER['DOCUMENT_ROOT'].$thumb_NUMBER_OF_THUMB_);
                    }