<?php
/**
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace common\modules\translator;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * TranslateBehavior Behavior. Allows to maintain translations of model.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\translate
 */
class TranslateBehavior extends Behavior
{
    /**
     * @var string the name of the translations relation
     */
    public $relation = 'translations';

    /**
     * @var string the language field used in the related table. Determines the language to query | save.
     */
    public $languageField = 'language';

    /**
     * @var array the list of attributes to translate. You can add validation rules on the owner.
     */
    public $translationAttributes = [];

    /**
     * @var ActiveRecord[] the models holding the translations.
     */
    private $_models = [];

    /**
     * @var string the language selected.
     */
    private $_language;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    /**
     * Make [[$translationAttributes]] writable
     * @param string $name
     * @param mixed $value
     * @throws \yii\base\UnknownPropertyException
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->translationAttributes)) {
            $this->getTranslation()->$name = $value;
        } else {
            parent::__set($name, $value);
        }
    }

    /**
     * Make [[$translationAttributes]] readable
     * @inheritdoc
     */
    public function __get($name)
    {
        if (!in_array($name, $this->translationAttributes) && !isset($this->_models[$name])) {
            return parent::__get($name);
        }

        if (isset($this->_models[$name])) {
            return $this->_models[$name];
        }

        $model = $this->getTranslation();
        return $model->$name;
    }

    /**
     * Expose [[$translationAttributes]] writable
     * @inheritdoc
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return in_array($name, $this->translationAttributes) ? true : parent::canSetProperty($name, $checkVars);
    }

    /**
     * Expose [[$translationAttributes]] readable
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return in_array($name, $this->translationAttributes) ? true : parent::canGetProperty($name, $checkVars);
    }

    /**
     * After Find
     */
    public function afterFind()
    {
        $this->populateTranslations();
        $this->getTranslation($this->getLanguage());
    }

    /**
     * After Insert
     */
    public function afterInsert()
    {
        $this->saveTranslation();
    }

    /**
     * After Update
     */
    public function afterUpdate()
    {
        $this->saveTranslation();
    }

    /**
     * Sets current model's language
     *
     * @param $value
     */
    public function setLanguage($value)
    {
        $value = strtolower($value);
        if (!isset($this->_models[$value])) {
            $this->_models[$value] = $this->loadTranslation($value);
        }
        $this->_language = $value;
    }

    /**
     * Returns current models' language. If null, will return app's configured language.
     * @return string
     */
    public function getLanguage()
    {
        if ($this->_language === null) {
            $this->_language = \Yii::$app->language;
        }
        return $this->_language;
    }

    /**
     * Saves current translation model
     * @return bool
     */
    public function saveTranslation()
    {
        $model = $this->getTranslation();
        $dirty = $model->getDirtyAttributes();
        if (empty($dirty)) {
            return true; // we do not need to save anything
        }
        /**
         * @var ActiveRecord $_model
         * @var \yii\db\ActiveQuery $relation
         */
        $_model = $this->owner;
        $relation = $_model->getRelation($this->relation);
        $model->{key($relation->link)} = $_model->getPrimaryKey();
        return $model->save();

    }

    /**
     * Returns a related translation model
     *
     * @param string|null $language the language to return. If null, current sys language
     *
     * @return ActiveRecord
     */
    public function getTranslation($language = null)
    {
        if ($language === null) {
            $language = $this->getLanguage();
        }

        if (!isset($this->_models[$language])) {
            $this->_models[$language] = $this->loadTranslation($language);
        }

        return $this->_models[$language];
    }

    /**
     * Loads all specified languages. For example:
     *
     * ```
     * $model->loadTranslations("en-US");
     *
     * $model->loadTranslations(["en-US", "es-ES"]);
     *
     * ```
     *
     * @param string|array $languages
     */
    public function loadTranslations($languages)
    {
        $languages = (array)$languages;

        foreach ($languages as $language) {
            $this->loadTranslation($language);
        }
    }

    /**
     * Loads a specific translation model
     *
     * @param string $language the language to return
     *
     * @return null|\yii\db\ActiveQuery|static
     */
    private function loadTranslation($language)
    {
        $translation = null;
        /**
         * @var ActiveRecord $class
         * @var $model ActiveRecord
         * @var \yii\db\ActiveQuery $relation
         */
        $model = $this->owner;
        $relation = $model->getRelation($this->relation);

        $class = $relation->modelClass;
        if ($model->getPrimarykey()) {
            $translation = $class::findOne(
                [$this->languageField => $language, key($relation->link) => $model->getPrimarykey()]
            );
        }
        if ($translation === null) {
            $translation = new $class;
            $translation->{key($relation->link)} = $model->getPrimaryKey();
            $translation->{$this->languageField} = $language;
        }

        return $translation;
    }

    /**
     * Populates already loaded translations
     */
    private function populateTranslations()
    {
        /**
         * Translation
         * @var $aRelated ActiveRecord
         * @var $model ActiveRecord
         * @var $_model ActiveRecord
         */
        $model = $this->owner;
        $aRelated = $model->getRelatedRecords();
        if (isset($aRelated[$this->relation]) && $aRelated[$this->relation] != null) {
            if (is_array($aRelated[$this->relation])) {
                foreach ($aRelated[$this->relation] as $_model) {
                    $this->_models[$_model->getAttribute($this->languageField)] = $_model;
                }
            } else {
                $_model = $aRelated[$this->relation];
                $this->_models[$_model->getAttribute($this->languageField)] = $_model;
            }
        }
    }
} 