<?php class ZohoWrapper
{
    const MAIN_URL = 'https://www.zohoapis.com/crm/v2';
    const RECORDS = '/Leads';

    const CODE_DUPLICATE = 'DUPLICATE_DATA';
    const CODE_SUCCESS = 'SUCCESS';

    protected $authKey;

    /**
     * ZohoWrapper constructor.
     *
     * @param string $authKey
     */
    public function __construct(string $authKey)
    {
        $this->authKey = $authKey;
    }

    /**
     * Get all records
     *
     * @return mixed
     */
    public function getRecords()
    {
        $options = [
            CURLOPT_URL => self::MAIN_URL . self::RECORDS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
        ];

        return $this->request($options);
    }

    /**
     * Create a new record
     *
     * @param array $data
     *
     * @return mixed
     */
    public function insert(array $data)
    {
        $options = [
            CURLOPT_URL => self::MAIN_URL . self::RECORDS,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode(['data' => [$data]])
        ];

        return $this->request($options);
    }

    /**
     * search record by phone number
     *
     * @param $phone
     *
     * @return mixed
     */
    public function searchPhone($phone)
    {
        $params = http_build_query([
            'phone' => $phone,
        ]);

        $options = [
            CURLOPT_URL => self::MAIN_URL . self::RECORDS . '/search?' . $params,
            CURLOPT_RETURNTRANSFER => true,
        ];

        return $this->request($options);
    }

    /**
     * convert record to contract
     *
     * @param $recordId
     * @param $ownerId
     *
     * @return mixed
     */
    public function convert($recordId, $ownerId)
    {
        $options = [
            CURLOPT_URL => self::MAIN_URL . self::RECORDS . '/' . $recordId . '/actions/convert',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode([
                'data' => [
                    [
                        'overwrite' => false,
                        'notify_lead_owner' => true,
                        'notify_new_entity_owner' => true,
                        'assign_to' => $ownerId,
                        'Deals' => [
                            'Deal_Name' => 'Test param',
                            'Amount' => 121,
                            'Closing_Date' => (new DateTime())->format('Y-m-d'),
                            "Stage" => "First stage"
                        ]
                    ]
                ]
            ])
        ];

        return $this->request($options);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function recordById($id)
    {
        $options = [
            CURLOPT_URL => self::MAIN_URL . self::RECORDS . '/' . $id,
            CURLOPT_RETURNTRANSFER => true,
        ];

        return $this->request($options)['data'][0] ?? false;
    }

    /**
     * Get Response Code of first item
     *
     * @param $response
     *
     * @return string
     */
    public function getResponseCode($response): string
    {
        return $response['data'][0]['code'] ?? false;
    }

    /**
     *
     * @param array|null $options
     *
     * @return mixed
     */
    protected function request(array $options = null)
    {
        $ch = curl_init();
        if ($options) {
            curl_setopt_array($ch, $options);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: ' . $this->authKey
        ));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}


