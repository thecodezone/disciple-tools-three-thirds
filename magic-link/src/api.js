import magicLinkRequest from "./magicLinkRequest";

export const getMeetings = async (params) => {
  return await magicLinkRequest('meetings', params)
}

export const getMeeting = async (id) => {
  return await magicLinkRequest('meeting', {
    'meeting_id': id
  })
}

export const login = async (data) => {
  return await magicLinkRequest('login', data,'POST')
}

export const logout = async (data) => {
  return await magicLinkRequest('logout', data,'POST')
}

export const createAccount = async (data) => {
  return await magicLinkRequest('register', data,'POST')
}

export const saveMeeting = async (data) => {
  return await magicLinkRequest('meeting', data,'PUT')
}
