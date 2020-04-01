<table>
  @foreach ($collection as $route)    
    <tr>
      <td style="width:200px;text-indent: 20px">{{implode('|', $route->methods())}}</td>
      <td style="text-indent: 20px">{{$route->uri()}}</td>
    </tr>
  @endforeach
</table>
