<form method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('ニックネーム') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $authUser->name }}" required autocomplete="name" autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="form-group row">
            <label for="inputFile" class="col-md-4 col-form-label text-md-right">プロフィール画像</label>
            <div class="input-group col-md-6">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="inputFile" name="image">
                    <label class="custom-file-label" for="inputFile" data-browse="参照">選択かドロップ</label>
                </div>
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary input-group-text" id="inputFileReset">取消</button>
                </div>
            </div>
        </div>
            @error('image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
    <div class="form-group row">
        <div class="col-md-6 offset-md-6 prof-img">
            @if($authUser->image !== null)
                <img src="/storage/profile_images/{{ $authUser->image }}" class="button" style="object-fit: cover">
            @else
                <img src="../img/noimage.jpeg" class="button">
            @endif

        </div>
    </div>
    <div class="form-group row mb-0 mt-4">
        <div class="col-md-8 offset-md-2">
            <button type="submit" class="btn btn-info btn-block">
                {{ __('ニックネームと画像を変更する') }}
            </button>
        </div>
    </div>
</form>