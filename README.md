<details>
write api without use api resource ,use regular api method,
at the time the 419 expire can apperar.
to solve this at the backend, 
under middleware csrf.phh
 protected $except = [
        'api/*'
    ];
</details>
