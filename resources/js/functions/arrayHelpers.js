/**
 * Summary. Split a large array into chunks
 *
 * Description. Takes a large array and splits it into an array of smaller arrays equal to or close to the number passed
 *
 * @since      1.0.0
 * @memberof helpers
 *
 * @param {Array}   array  The large array to split.
 * @param {Number}  size   How many smaller arrays you'd like it split into
 *
 * @return {Array}         Return the array of smaller arrays
 */

const _chunk = (array, size) => {
    const division = Math.ceil(array.length / size);
    console.log({ division })
    const loopCount = Math.floor(array.length / division)
    let arrayOfArrays = []
    for (let i = 0; i <= loopCount; i++) {
        const slice = array.slice(division * i, division * i + division);
        if (slice.length) {
            arrayOfArrays.push(array.slice(division * i, division * i + division))
        }
    }
    return arrayOfArrays
}

export { _chunk }
