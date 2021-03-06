<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PatientDetails;

/**
 * PatientDetailsSearch represents the model behind the search form about `common\models\PatientDetails`.
 */
class PatientDetailsSearch extends PatientDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'age', 'gender', 'status'], 'integer'],
            [['first_name', 'last_name', 'email', 'phone', 'profile_image', 'address', 'state', 'district', 'city', 'area', 'created_on'], 'safe'],
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
        $query = PatientDetails::find()->joinWith('appointments');;

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
            'age' => $this->age,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_on' => $this->created_on,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area]);
             $query->andWhere(['=','hospital_clinic_id',Yii::$app->user->identity->id]);
        $query->andWhere(['=','refer_id','0']);
        return $dataProvider;
    }
    public function search1($params)
    {
        $query = PatientDetails::find()->select(['id', 'age', 'gender', 'status','first_name', 'last_name', 'email', 'phone', 'profile_image', 'address', 'state', 'district', 'city', 'area', 'created_on'])->distinct();

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
            'age' => $this->age,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_on' => $this->created_on,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area]);
             
        $query->andWhere(['=','refer_id','0']);
        return $dataProvider;
    }
      public function search2($params)
    {
        $query = PatientDetails::find();

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
            'age' => $this->age,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_on' => $this->created_on,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area]);

        return $dataProvider;
    }
    public function search3($params)
    {
        $query = PatientDetails::find()->joinWith('appointments');

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
            'age' => $this->age,
            'gender' => $this->gender,
            'status' => $this->status,
            'created_on' => $this->created_on,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'profile_image', $this->profile_image])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'district', $this->district])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'area', $this->area]);
        $query->andWhere(['=','hospital_clinic_id',Yii::$app->user->identity->id]);
        $query->andWhere(['<>','refer_id','0']);

        return $dataProvider;
    }
}
// select dispatient.