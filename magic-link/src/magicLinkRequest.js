const request = (action, data = {}, method = "GET") => {
  return new Promise((resolve, reject) => {
    jQuery.ajax({
      type: method,
      data: Object.assign({
        action,
        parts: magicLink.parts
      }, data),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      url: magicLink.root + magicLink.parts.root + '/v1/' + magicLink.parts.type,
      beforeSend: function (xhr) {
        xhr.setRequestHeader('X-WP-Nonce', magicLink.nonce )
      },
      success: function (data) {
        resolve(data)
      },
      error: function (error) {
        reject(error)
      },
    })
  })
}

export default request
