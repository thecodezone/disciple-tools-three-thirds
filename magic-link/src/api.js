import magicLinkRequest from "./magicLinkRequest";

export const getMeetings = async () => {
  return await magicLinkRequest('meetings')
}

export const getMeeting = async (id) => {
  return await magicLinkRequest('meeting', {
    'id': id
  })
}
