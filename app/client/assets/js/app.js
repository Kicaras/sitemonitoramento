import {movies} from './shared/movies.js'
import axios from 'axios'

movies.forEach( movie =>{
    console.log( movie )
})


class Cinema
{
    constructor(filme)
    {
        this.filme = filme
        console.log(this.filme)
    }
}

const c = new Cinema("Um amor para recordar")


axios.get("http://httpbin.org/get").then(res=>{
    console.log(res)
})