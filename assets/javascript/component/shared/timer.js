export const formatTime = (time) => {
    let result = [0,0,0]
    if(time >= 3600){
        result[0] = Math.floor(time / 3600)
        time = time % 3600
    }
    if(time >= 60){
        result[1] = Math.floor(time / 60)
        time = time % 60
    }
    result[2] = time
    return `${result[0]}h ${result[1]}m ${result[2]}s`
}