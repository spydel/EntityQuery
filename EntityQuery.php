<?php namespace common\components;

use yii\base\Behavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class EntityQuery extends Behavior
{
    /* @var $owner EntityQuery | ActiveRecord */
    public $owner;

    /* @var $_query ActiveQuery */
    private $_query = [];

    /**
     * Устанавливает запрос.
     *
     * @param ActiveQuery $query
     * @return EntityQuery | ActiveRecord
     */
    public function set(ActiveQuery $query)
    {
        $this->_query = $query;

        return $this->owner;
    }

    /**
     * Добавляет запрос к запросу.
     *
     * @param ActiveQuery $query
     * @return EntityQuery
     */
    public function addQuery(ActiveQuery $query)
    {
        $this->set($query);

        return $this;
    }

    /**
     * Получить промежуточный запрос.
     * Для дополнения запроса.
     *
     * @return ActiveQuery
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * @return ActiveQuery[]
     */
    public function all()
    {
        return $this->owner->getDb()->cache(function() {
            return $this->_query->all();
        });
    }

    /**
     * @return ActiveQuery
     */
    public function one()
    {
        return $this->owner->getDb()->cache(function() {
            return $this->_query->one();
        });
    }
}