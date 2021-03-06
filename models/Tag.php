<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\caching\DbDependency;
use yii\db\Query;

/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $pid
 * @property integer $cid
 * @property integer $create_time
 *
 * @property Post $post
 */
class Tag extends ActiveRecord
{
    public $totalCount = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pid', 'create_time'], 'required'],
            [['pid', 'cid', 'create_time'], 'integer'],
            ['name', 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '标签ID',
            'name' => '标签',
            'pid' => '文章ID',
            'cid' => '分类ID',
            'create_time' => '创建时间',
        ];
    }

    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'pid']);
    }

    /**
     * 获取系统的常用tags，默认前10位
     * @param bool $refresh
     * @param int $limit 默认为10
     * @return mixed|null
     */
    public static function getTags($refresh = false, $limit = 0)
    {
        $cache_key = '__tags_' . $limit;

        $limit = intval($limit);

        if ($refresh)
            $items = [];
        else
            $items = Yii::$app->cache->get($cache_key);

        if (empty($items)) {

            $tag_array = self::find()
                ->select('id,name,create_time,COUNT(id) as totalCount')
                ->groupBy('name')
                ->orderBy(['totalCount' => SORT_DESC]);
            if($limit)
                $tag_array = $tag_array->limit($limit)->all();
            else
                $tag_array = $tag_array->all();

            if (empty($tag_array))
                return [];

            /* @var self[] $tag_array */
            foreach ($tag_array as $tag) {
                $items[] = [
                    'totalCount' => $tag->totalCount,
                    'name' => $tag->name,
                    'create_time' => $tag->create_time,
                    'url' => Url::to(['tag/show', 'name' => $tag->name])
                ];
            }
            $dp = new DbDependency();
            $dp->sql = (new Query())
                ->select('MAX(id)')
                ->from(self::tableName())
                ->createCommand()->rawSql;
            Yii::$app->cache->set(
                $cache_key,
                $items,
                3600,
                $dp
            );
        }
        return $items;
    }
}
