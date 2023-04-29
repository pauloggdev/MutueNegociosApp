
import axios from "axios"
import { baseUrl } from "../../config/global"


export default{

    state:{
        licencas:[]
    },

    mutations:{
        setLicencas(state, licencas){
            state.licencas = licencas
        }
    },
    actions:{

        MostrarLicencas({commit}){
            axios.get(`${baseUrl}/empresa/assinaturas`).then(res=>{
                state.licencas = res.data
            })
        }

    },
    getters:{
        licencas(state){
            return state.licencas
        }
    }

}