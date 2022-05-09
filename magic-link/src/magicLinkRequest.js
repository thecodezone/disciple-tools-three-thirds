const requests = {}

const request = (action, data = {}, method = "GET") => {
  if (requests[action] !== undefined)  {
    requests[action].abort()
  }
  return new Promise((resolve, reject) => {
    const options = {
      type: method,
      data: Object.assign({
        action,
        parts: magicLink.parts
      }, data),
      dataType: "json",
      url: magicLink.root + magicLink.parts.root + '/v1/' + magicLink.parts.type,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', magicLink.nonce )
      },
      success: function (data) {
        resolve(data)
        requests[action] = undefined
      },
      error: function (error) {
        reject(error)
        requests[action] = undefined
      },
    }

    if (method.toUpperCase() === 'GET') {
      options.contentType = "application/json; charset=utf-8"
    }
    requests[action] = jQuery.ajax(options)
  })
}

export default request
