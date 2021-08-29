<?php

namespace App\Http\Controllers;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Repositories\TagsInterface;
use Illuminate\Http\Request;

class TagController extends Controller
{

    private $tags;

    public function __construct(TagsInterface $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Display starred repository for specific user
     *
     * @param $username
     * @param Request $request
     * @return void
     */
    public function adds($username,Request $request)
    {
        return $this->tags->adds($username,$request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $username
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy($username, $name)
    {
        return $this->tags->destroy($username, $name);
    }

    /**
     * add the specified resource from storage.
     *
     * @param $username
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store($username, Request $request)
    {
        return $this->tags->add($username, $request);
    }

    /**
     * edit the specified resource from storage.
     *
     * @param $username
     * @param $id
     * @param Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update($username, $id, Request $request)
    {
        return $this->tags->edit($username, $request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $username
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function search($username, $name)
    {
        return $this->tags->search($name, $username);
    }

}
