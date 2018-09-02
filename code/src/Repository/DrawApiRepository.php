<?php

namespace App\Repository;

use App\Entity\Draw;
use App\Exceptions\ApiErrorException;
use App\Exceptions\NotFoundException;
use App\Interfaces\IApiClient;
use App\Interfaces\IResultApi;

class DrawApiRepository implements IResultApi
{
    private $apiClientAdapter;
    private $drawFallbackApiRepository;
    private $drawDbRepository;

    public function __construct(
        IApiClient $apiClientAdapter,
        IResultApi $drawFallbackApiRepository,
        DrawDbRepositoryInterface $drawDbRepository
    )
    {
        $this->apiClientAdapter = $apiClientAdapter;
        $this->drawFallbackApiRepository = $drawFallbackApiRepository;
        $this->drawDbRepository = $drawDbRepository;
    }

    /**
     * @return Draw
     * @throws NotFoundException
     */
    public function fetch(): Draw
    {
        try {
            $data = $this->apiClientAdapter->request(
                'GET',
                'results.php',
                ['query' => ['game' => 'euromillions']]
            );
            
            if (isset($data['error']) || !is_array($data['results'])) {
                throw new ApiErrorException("Api returned an error");
            }

            $draw = $this->createDrawInstance($data);

        } catch (ApiErrorException $e) {
            try {
                $draw = $this->drawFallbackApiRepository->fetch();
            } catch (ApiErrorException $e) {
                throw new NotFoundException("Could not retrieve results from api.");
            }
        } catch (\Exception $e) {
            throw new NotFoundException("Could not retrieve results from api.");
        }

        $this->drawDbRepository->save($draw);

        return $draw;
    }

    private function createDrawInstance($data)
    {
        return new Draw($data['lottery_id'],
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



