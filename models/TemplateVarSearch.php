<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TemplateVar;

/**
 * TemplateVarSearch represents the model behind the search form of `app\models\TemplateVar`.
 */
class TemplateVarSearch extends TemplateVar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['var_id', 'template_id', 'required'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TemplateVar::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'var_id' => $this->var_id,
            'template_id' => $this->template_id,
            'required' => $this->required,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        return $dataProvider;
    }
}
