<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CompanySearch represents the model behind the search form of `app\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_count', 'profile_id', 'is_new'], 'integer'],
            [['name', 'org_form', 'email'], 'safe'],
            [['last_payment'], 'date', 'format' => 'php:d.m.Y'],
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
        $query = Company::find();

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
            'id' => $this->id,
            'employee_count' => $this->employee_count,
            'profile_id' => $this->profile_id,
            'is_new' => $this->is_new,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'org_form', $this->org_form])
            ->andFilterWhere(['like', 'email', $this->email]);

        if ($this->last_payment) {
            $query->andFilterWhere(['<=', 'last_payment', (new \DateTime($this->last_payment))
                ->sub(new \DateInterval('P1Y'))
                ->format('Y-m-d')]);
        }


        return $dataProvider;
    }
}
