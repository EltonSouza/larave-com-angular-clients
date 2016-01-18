<?php
/**
 * Created by PhpStorm.
 * User: Elton
 * Date: 30/12/2015
 * Time: 16:57
 */

namespace CodeProject\Repositories;

use CodeProject\Entities\Client;
use Prettus\Repository\Eloquent\BaseRepository;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{
    public function model()
    {
        return Client::class;
    }

    public function checkClientExist($clientId)
    {

        if(count($this->findWhere(['id'=>$clientId]))){
            return true;
        }

        return false;
    }

    public function checkClientHasProject($clientId)
    {

        if(count($this->find($clientId)->project)){
            return true;
        }

        return false;
    }


}