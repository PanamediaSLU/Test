<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Exceptions\ApiErrorException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IApiClient;

class DrawApiRepository implements DrawApiRepositoryInterface
{
    private $apiClientAdapter;

    public function __construct(IApiClient $apiClientAdapter)
    {
        $this->apiClientAdapter = $apiClientAdapter;
    }

    /**
     * @param array $criteria
     * @param array $orderBy
     * @return Draw
     * @throws NotFoundException
     */
    public function findOneBy(array $criteria, array $orderBy = []): Draw
    {
        try {
            $response = $this->apiClientAdapter->request(
                'GET',
                'results.php',
                ['query' => $criteria]
            );
        } catch (ApiErrorException $e) {
            throw new NotFoundException("Could not retrieve results from api.");
        }

        $data = $response->fetch();

        if (isset($data['error']) || !is_array($data['results'])) {
            throw new NotFoundException("Api returned an error");
        }

        return new Draw($data['id'],
            $data['lottery_id'],
            $data['draw']['date'],
            $data['results']['result_regular_number_one'],
            $data['results']['result_regular_number_two'],
            $data['results']['result_regular_number_three'],
            $data['results']['result_regular_number_four'],
            $data['results']['result_regular_number_five'],
            $data['results']['result_lucky_number_one'],
            $data['results']['result_lucky_number_two'],
            $data['results']['jackpot_amount'],
            $data['results']['jackpot_currency_name']);
    }
}



