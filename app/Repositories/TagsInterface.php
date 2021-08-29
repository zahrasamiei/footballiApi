<?php

namespace App\Repositories;

use App\Http\Requests\TagRequest;
use Illuminate\Http\Request;

interface TagsInterface
{

    /**
     * add tags
     *
     * @method  POST api/users/{user}/addTags
     * @access  public
     * @param $username
     * @param $data
     */

    public function adds($username,$data);

    /**
     * add tag
     *
     * @method  POST  api/users/{user}/tag/add
     * @access  public
     * @param $username
     * @param Request $request
     */

    public function add($username,Request $request);

    /**
     * add tag
     *
     * @method  PUT|PATCH  api/users/{user}/tag/update
     * @access  public
     * @param $username
     * @param $request
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function edit($username, $request, $id);

    /**
     * search tags by part of name column
     *
     * @method  GET api/users/{user}/search/{tag}
     * @access  public
     * @param $tag
     * @param $username
     * @return bool|\Illuminate\Http\JsonResponse
     */

    public function search($tag, $username);

    /**
     * destroy specific tag
     *
     * @method  DELETE api/users/{user}/tags/{tag}/destroy
     * @access  public
     * @param $username
     * @param $name
     */

    public function destroy($username, $name);

}
