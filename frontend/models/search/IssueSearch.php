<?php


namespace frontend\models\search;


use frontend\models\Issue;
use kartik\builder\TabularForm;
use kartik\widgets\StarRating;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class IssueSearch extends Issue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rating'], 'integer'],
            [['name', 'solution'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Issue::find()->indexBy('id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'name' => $this->name,
            'solution' => $this->solution,
        ]);

        return $dataProvider;
    }


    public function getFormAttributes()
    {
        $typeInput = Yii::$app->user->can('changeNameAndSolution') ? TabularForm::INPUT_TEXT : TabularForm::INPUT_STATIC;
        $readOnly = Yii::$app->user->can('changeRating') ? false : true;
        return [
            'id' => [
                'type' => TabularForm::INPUT_HIDDEN,
                'columnOptions' => ['hidden' => true]
            ],
            'name' => [
                'type' => $typeInput,
            ],
            'solution' => [
                'type' => $typeInput,
            ],
            'rating' => [
                'type' => TabularForm::INPUT_WIDGET,
                'widgetClass' => StarRating::classname(),
                'options' => [
                    'pluginOptions' => [
                        'step' => 1,
                        'showCaption' => false,
                        'size' => 'sm',
                        'readonly' => $readOnly,
                    ]
                ],
            ],
        ];
    }
}