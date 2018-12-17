<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StdFeeDetails;

/**
 * StdFeeDetailsSearch represents the model behind the search form about `common\models\StdFeeDetails`.
 */
class StdFeeDetailsSearch extends StdFeeDetails
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fee_id', 'created_by', 'updated_by'], 'integer'],
            [['admission_fee', 'addmission_fee_discount', 'net_addmission_fee', 'monthly_fee', 'monthly_fee_discount', 'net_monthly_fee'], 'number'],
            [['std_id', 'created_at', 'updated_at'], 'safe'],
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
        $query = StdFeeDetails::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('std');
        $query->andFilterWhere([
            'fee_id' => $this->fee_id,
            'admission_fee' => $this->admission_fee,
            'addmission_fee_discount' => $this->addmission_fee_discount,
            'net_addmission_fee' => $this->net_addmission_fee,
            'monthly_fee' => $this->monthly_fee,
            'monthly_fee_discount' => $this->monthly_fee_discount,
            'net_monthly_fee' => $this->net_monthly_fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);
        $query->andFilterWhere(['like', 'std_personal_info.std_name', $this->std_id]);
        return $dataProvider;
    }
}
