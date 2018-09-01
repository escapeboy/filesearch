<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FileSearch</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <style>
        body {
            padding-top: 5rem;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
  </head>

  <body>

    <div class="container">

      <div class="starter-template">
          <div class="row">
              <div class="col-12 mb-3">
                  <form method="get" action="">
                      <div class="input-group">
                          <input type="search" class="form-control" name="q" id="q" placeholder="Type query here and press Enter" value="{{request('q')}}">
                          <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                          </div>
                      </div>
                  </form>
              </div>
          </div>
          @if(isset($items))
              <div class="table-responsive">
                  <table class="table table-bordered table-striped text-left">
                      <thead>
                      <tr>
                          <th>File</th>
                          <th>Line #</th>
                          <th>Content</th>
                      </tr>
                      </thead>
                      @if(count($items))
                      <tbody>
                      @foreach($items as $file => $lines)
                          @foreach($lines as $line_num => $content)
                          <tr>
                              <td>{{$file}}</td>
                              <td>{{$line_num}}</td>
                              <td>
                                  <code>
                                  {!! @nl2br(file($file)[$line_num-1]) !!}
                                  {!! nl2br(preg_replace('/('.request('q').')/i', '<strong class="text-success">$1</strong>', $content)) !!}
                                  {!! @nl2br(file($file)[$line_num+1]) !!}
                                  </code>
                              </td>
                          </tr>
                          @endforeach
                      @endforeach
                      </tbody>
                      @else
                          <tbody>
                          <tr>
                              <td colspan="3" class="text-center">No results found</td>
                          </tr>
                          </tbody>
                      @endif
                  </table>
              </div>
          @endif
      </div>



    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Holder.js for placeholder images -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.4/holder.min.js"></script>
  </body>
</html>
