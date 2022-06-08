/**
 * Split an array into chunks of a given size
 * @param arr
 * @param chunkSize
 * @returns {[]}
 */
export const chunkArray = (arr, chunkSize) => {
  const res = [];
  for (let i = 0; i < arr.length; i += chunkSize) {
    const chunk = arr.slice(i, i + chunkSize);
    res.push(chunk);
  }
  return res;
}

/**
 * Because writing {__html: html} is ugly
 * @param html
 * @returns {{__html}}
 */
export const useHtml = ( html ) => {
  return {__html: html}
}

