<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->only('username', 'limit');

        $username = $input['username'];
        $limit = $input['limit'];

        $data = $this->getDataFromGuzzle($request, $username, $limit);
        return response()->json($data, 200);

    }

    public function getDataFromGuzzle($request, $username = "", $limit = 10) {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://jsonmock.hackerrank.com/api/articles?author='.$username,[]);
        $response = json_decode($response->getBody()->getContents());

        for ($i=1; $i <= $response->total_pages ; $i++) { 
          $client = new \GuzzleHttp\Client();
          $response = $client->request('GET', 'https://jsonmock.hackerrank.com/api/articles?author='.$username.'&page='.$i,[]);

          if($response)
          {
            $response = json_decode($response->getBody()->getContents());

            foreach ($response->data as $key => $value) {
                $finalData[] = $value;
            }   

        }

        $collection = collect($finalData);
        return $collection->sortBy('num_comments')->take($limit)->toArray();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
