<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ClientService;
use Illuminate\Http\Request;

//use CodeProject\Http\Requests;


class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var ClientService
     */
    private $service;

    /**
     * @param ClientRepository $repository
     * @param ClientService $service
     */

    public function __construct(ClientRepository $repository, ClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if($this->repository->checkClientExist($id) == false){
            return ['error' => "Client ID: {$id} not found"];
        }

        return $this->repository->find($id);
        //return Client::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*$client = Client::find($id); //consulta dos dados

        $client->update($request->all(),$id); //atualiza os dados

        return $client; //retornar os dados para serialização em JSON*/

        //return Client::find($id)->update($request->all());
        //return $this->repository->update($request->all(), $id);

        if($this->repository->checkClientExist($id) == false){
            return ['error' => "Client ID: {$id} not found"];
        }

        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Client::find($id)->delete();

        if($this->repository->checkClientExist($id) == false){
            return ['error' => "Client ID: {$id} not found"];
        }

        if($this->repository->checkClientHasProject($id) == true){
            return ['error' => "Client ID: {$id} can not be deleted"];
        }

        $this->repository->delete($id);
    }
}
