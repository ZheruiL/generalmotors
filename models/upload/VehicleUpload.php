<?php
namespace app\models\upload;

use yii\base\Model;
use yii\web\UploadedFile;

class VehicleUpload extends Model
{
    /**
     * @var UploadedFile
     */
    public $greyCard;

    public function rules()
    {
        return [
            [['greyCard'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, pdf'],
        ];
    }

    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'documents/vehicle/'.$id.'/';
            if(!is_dir($path)){
                mkdir($path);
            }
            $this->greyCard->saveAs( $path. $this->greyCard->baseName . '.' . $this->greyCard->extension);
            return true;
        } else {
            return false;
        }
    }
}